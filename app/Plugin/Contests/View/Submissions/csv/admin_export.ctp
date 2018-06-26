<?php
$this->Csv->addRow($fields);

foreach($submissions as $submission){
    $this->Csv->addRow($submission);
}

echo $this->Csv->render('export.csv');
?>