<?php
class TemplateRenderer
{
    public static function render($title = "Document", $content = null, $navbarContent = null, $sidebarContent = null, $message = null, $errorMessage = null)
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../dist/style.css">
            <title><?php echo $title; ?></title>
        </head>

        <body>
            <div class="container">
                <?php echo $message ? "<div class=\"message_container\">$message</div>" : null; ?>
                <?php echo $errorMessage ? "<div class=\"erreur_container\">$errorMessage</div>" : null; ?>
                <?php echo $navbarContent ? "<div class=\"navbar\">$navbarContent</div>" : null; ?>
                <?php echo $sidebarContent ? "<div class=\"sidebar\">$sidebarContent</div>" : null; ?>
                <?php echo $content ? "<div class=\"content\">$content</div>" : null; ?>
            </div>
            <script src="../dist/app-bundle.js"></script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}
