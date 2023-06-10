<?php
class TemplateRenderer
{
    private static $message;
    private static $msgTitle;
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

        </head>

        <body>
            <?php echo self::renderNavbar(self::$navbarContent) ?>
            <?php echo self::renderMessage(self::$msgTitle, self::$message); ?>
            <div class="container">
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

    public static function setMessage($msgTitle, $message)
    {
        self::$msgTitle = $msgTitle;
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

    private static function renderMessage($msgTitle, $message)
    {
        if ($message) {
            return '
            <div class="toast-container position-fixed bottom-0 end-0 p-3 ">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                    <strong class="me-auto">' . $msgTitle . '</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-bg-primary">'
                . $message .
                '</div>
                </div>
                </div>
            ';
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
