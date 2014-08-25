<?php
use PHPHD\View\Html;
use PHPHD\Data\File;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"> 
        <title>Decedent Code</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script>
        $(function() {
            $( "#files" ).accordion({
                active: false,
                collapsible: true,
                heightStyle: "content"
            });
        });
        </script>
        <style>
            li {
                list-style-type: none;
            }
            li.used {
                background-color: palegreen;
            }
            li.unUsed {
                background-color: palevioletred;
            }
            pre {
                margin: 0px;
            }
        </style>
    </head>
    <body>
        <h1>Decedent Code</h1>
        <div id="files">
        <?php foreach (Html::$data['unusedCode'] as $filePath => $lines): ?>
            <h3><?php echo $filePath ?></h3>
            <div>
            <ul class="file">
                <?php foreach ($lines as $number => $line): ?>
                    <li <?php if ($line[1] === File::UNUSED_LINE) { echo 'class="unUsed"'; } elseif($line[1] === File::USED_LINE){ echo 'class="used"'; } ?>>
                        <pre><?php echo $number + 1 ?>: <?php echo htmlentities($line[0]) ?></pre>
                    </li>
                <?php endforeach; ?>
            </ul>
            </div>
        <?php endforeach; ?>
        </div>
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