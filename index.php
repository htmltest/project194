<?php
    require_once 'vendor/autoload.php';

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            'fonts',
        ]),
        'fontdata' => $fontData + [
            'timesnewroman' => [
                'R' => 'times.ttf',
                'B' => 'timesbd.ttf'
            ]
        ],
        'default_font' => 'timesnewroman',
        'format' => 'A4-L'
    ]);

    $stylesheet = file_get_contents('style.css');
    $html = file_get_contents('index.html');

    $mpdf->SetTitle('Отчет о достижении результатов предоставления гранта');

    $mpdf->SetHTMLFooter('<div class="footer">
            <table>
                <tbody>
                    <tr>
                        <td class="footer-number">3.2021 <span class="footer-number-value">| E324-79E4-E2CA</span></td>
                        <td class="footer-page">{PAGENO}</td>
                    </tr>
                </tbody>
            </table>
        </div>');

    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->Output();
?>