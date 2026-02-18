<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use PDO;

final class ReceiptController extends Controller
{
    // GET /orders/{id}/receipt
    public function download(): void
    {

        $orderId = $this->req->getInt('id'); // потому что Router подмешал params в query
        if ($orderId <= 0) {
            \App\Core\Response::fail('Bad order id', 400);
        }

        $clientId = Session::requireClientId(); // чек только владельцу
        // $orderId = (int)$id;
        // if ($orderId <= 0) {
        //     $this->fail('Некорректный id заказа');
        // }

        // 1) Шапка заказа (проверяем владельца)
        $st = $this->pdo->prepare("
            SELECT id_заказа, Итоговая_сумма, Статус, Дата_заказа
            FROM заказ
            WHERE id_заказа = ? AND id_клиента = ?
            LIMIT 1
        ");
        $st->execute([$orderId, $clientId]);
        $order = $st->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            $this->fail('Заказ не найден или нет доступа', 404);
        }

        // 2) Позиции заказа
        $st = $this->pdo->prepare("
            SELECT Название_услуги, Количество, Цена_единицы, Сумма
            FROM позиции_заказа
            WHERE id_заказа = ?
            ORDER BY id_позиции ASC
        ");
        $st->execute([$orderId]);
        $items = $st->fetchAll(PDO::FETCH_ASSOC);

        // На всякий случай: если таблицы позиций нет/пусто
        if (!$items) {
            $items = [];
        }

        // 3) Генерация PDF
        $erip = '000000'; // примерный код ЕРИП
        $this->renderPdfReceipt($order, $items, $erip);
    }

    private function renderPdfReceipt(array $order, array $items, string $erip): void
    {
        // ReportLab в PHP нет 🙂 поэтому в PHP обычно используют TCPDF/FPDF/mpdf.
        // Ниже — вариант на TCPDF (самый частый в учебных проектах).

        // Если TCPDF ещё не подключен:
        // composer require tecnickcom/tcpdf
        // и убедись, что у тебя есть vendor/autoload.php

        require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

        $orderId = (int)$order['id_заказа'];
        $date = $order['Дата_заказа'] ?? '';
        $total = (float)($order['Итоговая_сумма'] ?? 0);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Adrasteia');
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetAuthor('Adrasteia');
        $pdf->SetTitle("Чек заказа #{$orderId}");
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();

        $html = '<h2 style="text-align:center;">Счёт на оплату</h2>';
        $html .= '<p><b>Заказ №:</b> ' . $orderId . '<br>';
        $html .= '<b>Дата:</b> ' . htmlspecialchars((string)$date) . '<br>';
        $html .= '<b>Код ЕРИП для оплаты:</b> <span style="font-size:14px;">' . htmlspecialchars($erip) . '</span></p>';

        $html .= '<h3>Список услуг</h3>';
        $html .= '<table border="1" cellpadding="6">
                    <thead>
                      <tr>
                        <th width="55%"><b>Услуга</b></th>
                        <th width="15%"><b>Кол-во</b></th>
                        <th width="15%"><b>Цена</b></th>
                        <th width="15%"><b>Сумма</b></th>
                      </tr>
                    </thead>
                    <tbody>';

        if (count($items) === 0) {
            $html .= '<tr><td colspan="4">Позиции не найдены</td></tr>';
        } else {
            foreach ($items as $it) {
                $name = htmlspecialchars((string)($it['Название_услуги'] ?? ''));
                $qty  = (int)($it['Количество'] ?? 0);
                $unit = (float)($it['Цена_единицы'] ?? 0);
                $sum  = (float)($it['Сумма'] ?? ($unit * $qty));

                $html .= '<tr>
                            <td width="55%">' . $name . '</td>
                            <td width="15%">' . $qty . '</td>
                            <td width="15%">' . number_format($unit, 2, '.', ' ') . '</td>
                            <td width="15%">' . number_format($sum, 2, '.', ' ') . '</td>
                          </tr>';
            }
        }

        $html .= '</tbody></table>';
        $html .= '<h3 style="text-align:right;">Итого к оплате: ' . number_format($total, 2, '.', ' ') . ' BYN</h3>';
        $html .= '<p style="margin-top:25px; color:#666;">Спасибо за заказ. Оплата по коду ЕРИП возможна в приложении банка.</p>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="receipt-order-' . $orderId . '.pdf"');
        $pdf->Output('receipt.pdf', 'D');
        exit;
    }

    private function fail(string $msg, int $code = 400): void
    {
        http_response_code($code);
        echo $msg;
        exit;
    }
}
