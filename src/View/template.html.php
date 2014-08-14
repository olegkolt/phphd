<?php
use PHPHD\View\Html;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Decedent Code</title>
    </head>
    <style>
        li {
            list-style-type: none;
        }
        pre {
            margin: 0px;
        }
    </style>
    <body>
        <h1>Decedent Code</h1>

        <?php foreach (Html::$data['unusedCode'] as $filePath => $lines): ?>
            <p><b><?php echo $filePath ?></b></p>
            
            <ul>
                <?php foreach ($lines as $number => $line): ?>
                    <li>
                        <pre><?php echo $number + 1 ?>: <?php echo $line ?></pre>
                    </li>
                <?php endforeach; ?>
            </ul>
        
        <?php endforeach; ?>
        <?php if (isset(Html::$data['dir'])): ?>
            <h1>Decedent files in <?php echo Html::$data['dir'] ?></h1>
        
            <ul>
                <?php foreach (Html::$data['unusedFiles'] as $filePath): ?>
                    <li>
                        <?php echo $filePath ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </body>
</html>