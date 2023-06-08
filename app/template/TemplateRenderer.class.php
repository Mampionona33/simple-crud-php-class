<?php
class TemplateRenderer
{
    private static $message;
    private static $errorMessage;
    private static $navbarContent;

    public static function render($title = "Document", $content = null, $sidebarContent = null)
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
            <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
            <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        </head>

        <body>
            <?php echo self::renderNavbar(self::$navbarContent) ?>
            <div class="container">
                <?php echo self::renderMessage(self::$message); ?>
                <?php echo self::renderErrorMessage(self::$errorMessage); ?>
                <?php echo $sidebarContent; ?>
                <?php echo $content; ?>
            </div>
            <script src="../dist/app-bundle.js"></script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }

    public static function setMessage($message)
    {
        self::$message = $message;
    }

    public static function setNavbarContent($navbarContent)
    {
        self::$navbarContent = $navbarContent;
    }

    public static function setError($errorMessage)
    {
        self::$errorMessage = $errorMessage;
    }

    private static function renderMessage($message)
    {
        if ($message) {
            return "<div class=\"message_container\">$message</div>";
        }
        return null;
    }
    private static function renderNavbar($navBar)
    {
        if ($navBar) {
            return "<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark fixed-top ps-4 text-capitalize\">$navBar</nav>";
        }
        return null;
    }

    private static function renderErrorMessage($errorMessage)
    {
        if ($errorMessage) {
            return "<div class=\"erreur_container\">$errorMessage</div>";
        }
        return null;
    }
}
