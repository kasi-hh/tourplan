<?php
ob_clean();
ob_start();
?>
<?php echo '<?xml version="1.0"?>' ?>
<?php echo '<?mso-application progid="Excel.Sheet"?>'?>
<Workbook
    xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="urn:schemas-microsoft-com:office:spreadsheet"
    xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">

    <Styles>
        <Style ss:ID="Default" ss:Name="Normal">
            <Alignment ss:Vertical="Bottom"/>
            <Borders/>
            <Font/>
            <Interior/>
            <NumberFormat/>
            <Protection/>
        </Style>
        <Style ss:ID="s27">
            <Font x:Family="Swiss" ss:Color="#0000FF" ss:Bold="1"/>
        </Style>
    </Styles>

    <Worksheet ss:Name="Sheet1">
        <ss:Table>
            <ss:Row>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">Start</Data></ss:Cell>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">Name/Ort</Data></ss:Cell>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">KM</Data></ss:Cell>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">Minuten</Data></ss:Cell>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">Aufenthalt</Data></ss:Cell>
                <ss:Cell  ss:StyleID="s27"><Data ss:Type="String">Extra</Data></ss:Cell>
            </ss:Row>
            <?php foreach($data as $row): ?>
                <ss:Row>
                    <ss:Cell><Data ss:Type="String"><?php echo $row['start'] ?></Data></ss:Cell>
                    <ss:Cell><Data ss:Type="String"><?php echo str_replace('<br>',', ',$row['name']) ?></Data></ss:Cell>
                    <ss:Cell><Data ss:Type="String"><?php echo $row['km'] ?></Data></ss:Cell>
                    <ss:Cell><Data ss:Type="String"><?php echo $row['min'] ?></Data></ss:Cell>
                    <ss:Cell><Data ss:Type="String"><?php echo $row['auf'] ?></Data></ss:Cell>
                    <ss:Cell><Data ss:Type="String"><?php echo $row['extra'] ?></Data></ss:Cell>
                </ss:Row>
            <?php endforeach; ?>
        </ss:Table>
    </Worksheet>
</Workbook>
<?php
$content = ob_get_clean();
file_put_contents(__DIR__.'/public/excel.xml',$content);