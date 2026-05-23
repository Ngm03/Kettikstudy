<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Договор № <?php echo $contract_number; ?></title>
    <style>
        body { font-family: 'dejavusans', sans-serif; font-size: 10pt; line-height: 1.3; }
        h1 { font-size: 14pt; text-align: center; font-weight: bold; margin-bottom: 20px; }
        p { margin-bottom: 10px; text-align: justify; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 10px; text-transform: uppercase; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .header-table { width: 100%; margin-bottom: 20px; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .payment-details { margin-top: 20px; width: 100%; }
        .payment-details td { width: 50%; vertical-align: top; padding-right: 20px; }
        .signatures { margin-top: 40px; width: 100%; }
        .signatures td { width: 50%; vertical-align: top; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="text-align: left;">
                Договор № <?php echo $contract_number; ?> /2025<br>
                О возмездном оказании услуг
            </td>
            <td style="text-align: right;">
                г. Алматы<br>
                «<?php echo $date_day; ?>» <?php echo $date_month; ?> 2025 г.
            </td>
        </tr>
    </table>

    <p>
        Индивидуальный предприниматель <strong>«KETTIK STUDY POLAND 1»</strong>, именуемое в дальнейшем <strong>Исполнитель</strong>, в лице директора Аппасова Алия, действующего на основании Устава, с одной стороны, и
    </p>
    <p>
        <strong><?php echo $customer_name; ?></strong> (ИИН: <?php echo $customer_iin; ?>), именуемый(ая) в дальнейшем <strong>Заказчик</strong>,
        также в дальнейшем именуемые Сторонами, заключили настоящий договор (далее – Договор) о нижеследующем:
    </p>

    <div class="section-title">1. ПРЕДМЕТ ДОГОВОРА</div>
    <p>
        1.1. Исполнитель обязуется оказать, а Заказчик принять и оплатить услуги по консультированию и сопровождению поступления
        <?php echo $student_relation ?? 'сына (дочери)'; ?> <strong><?php echo $student_name; ?></strong> (ИИН <?php echo $student_iin; ?>)
        в колледж по специальности <strong><?php echo $specialty; ?></strong> в Республике Польша (далее – Услуги), согласно Приложению 1 (Техническая спецификация).
    </p>
    <p>1.2. Услуги осуществляются в пределах срока и суммы, установленных настоящим Договором.</p>
    <p>1.3. Перечисленные ниже документы и условия, оговоренные в них образуют данный Договор и считаются его неотъемлемой частью, а именно:
        <br>1) Договор;
        <br>2) Техническая спецификация (Приложение 1 к Договору);
        <br>3) Счет на оплату через приложение KASPI.KZ.
    </p>
    <p>1.4. Услуга, поставленная в рамках данного Договора, должна соответствовать или быть выше технических характеристик, указанных в Технической спецификации.</p>

    <div class="section-title">2. СТОИМОСТЬ ДОГОВОРА И ПОРЯДОК ОПЛАТЫ</div>
    <p>2.1. Общая сумма Договора составляет – <strong>900 000 (девятьсот тысяч) тенге</strong>.</p>
    <p>2.2. При 100% оплате за услуги компании, действует скидка в размере 100 000 (сто тысяч) тенге.</p>
    <p>2.3. Скидка в пункте 2.2. также действует, если Заказчик произведет оплату в течение 2-х недель с момента оплаты первой части.</p>

    <div class="section-title">3. ПРАВА И ОБЯЗАННОСТИ СТОРОН</div>
    <p><strong>Исполнитель обязуется:</strong></p>
    <p>3.1. Обеспечить полное и надлежащее исполнение взятых на себя обязательств. Оказывать услуги качественно и в срок.</p>
    <p>3.2. Исполнителем оказываются услуги согласно Технической спецификации (см. Приложение 1), включая: консультации, регистрацию в учебном заведении, переводы документов, визовую поддержку, поиск жилья.</p>
    
    <p><strong>Заказчик обязуется:</strong></p>
    <p>3.13. Своевременно предоставить все необходимые документы и оплатить Услуги.</p>
    <p>3.14. Не раскрывать конфиденциальную информацию третьим лицам.</p>

    <div class="section-title">4. ОТВЕТСТВЕННОСТЬ СТОРОН</div>
    <p>4.1. Стороны несут ответственность в соответствии с законодательством Республики Казахстан и Республики Польша.</p>

    <div class="section-title">5. СРОК ДЕЙСТВИЯ</div>
    <p>8.1. Настоящий Договор вступает в силу со дня его подписания и действует по 1 декабря 2025 года.</p>

    <br><br>
    
    <div class="section-title">10. ЮРИДИЧЕСКИЕ АДРЕСА И РЕКВИЗИТЫ СТОРОН</div>
    <table class="payment-details">
        <tr>
            <td>
                <strong>Исполнитель:</strong><br>
                ИП «KETTIK STUDY POLAND 1»<br>
                БИН: 890227451306<br>
                г. Астана, ул. Карасай Батыра 25/1 - 38<br>
                Email: kettikstudy@gmail.com<br>
                Тел: +48 506 304 046<br><br>
                _______________________<br>
                Алия Аппасова
            </td>
            <td>
                <strong>Заказчик:</strong><br>
                <?php echo $customer_name; ?><br>
                ИИН: <?php echo $customer_iin; ?><br>
                Адрес: <?php echo $customer_address; ?><br>
                Тел: <?php echo $customer_phone; ?><br>
                Email: <?php echo $customer_email; ?><br><br>
                _______________________<br>
                (Подпись)
            </td>
        </tr>
    </table>

    <br pagebreak="true"/>

    <h1 class="text-center">Приложение 1</h1>
    <p class="text-center">к Договору № <?php echo $contract_number; ?> /2025 от «<?php echo $date_day; ?>» <?php echo $date_month; ?> 2025 года</p>
    
    <div class="section-title text-center">Техническая спецификация</div>
    <p><strong>Цель:</strong> Поступление в колледж в Республике Польша.</p>
    <p><strong>Услуги Исполнителя (входят в стоимость):</strong></p>
    <ul>
        <li>Консультация по выбору учебного заведения и специальности.</li>
        <li>Регистрация кандидата в приемной комиссии.</li>
        <li>Присяжный перевод документов.</li>
        <li>Помощь в оформлении визы и страховки.</li>
        <li>Бронирование общежития.</li>
        <li>Встреча в аэропорту и заселение.</li>
        <li>Помощь в получении карты побыта (ID карты студента) и открытии банковского счета.</li>
    </ul>

</body>
</html>
