<?php
class TemplateRenderer
{
    private static $message;
    private static $msgTitle;
    private static $errorMessage;
    private static $errorTitle;
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
            <?php echo self::renderNavbar() ?>
            <?php echo self::renderMessage(); ?>
            <?php echo self::renderErrorMessage(); ?>
            <div class="container">
                <?php echo $sidebarContent; ?>
                <?php echo $content; ?>
            </div>
            <script src="../dist/app-bundle.js"></script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }

    public static function setMessage($msgTitle, $message): void
    {
        self::$msgTitle = $msgTitle;
        self::$message = $message;
    }

    public static function setNavbarContent($navbarContent): void
    {
        self::$navbarContent = $navbarContent;
    }

    public static function setError($errorTitle, $errorMessage): void
    {
        self::$errorTitle = $errorTitle;
        self::$errorMessage = $errorMessage;
    }

    private static function renderMessage()
    {
        if (self::$message) {
            return '
            <div class="toast-container position-fixed bottom-0 end-0 p-3 ">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                    <strong class="me-auto">' . self::$msgTitle . '</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-bg-primary">'
                . self::$message .
                '</div>
                </div>
                </div>
            ';
        }
        return null;
    }
    private static function renderNavbar()
    {
        if (self::$navbarContent) {
            return '<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark fixed-top ps-4 text-capitalize\">' . self::$navbarContent . '</nav>';
        }
        return null;
    }

    private static function renderErrorMessage()
    {
        if (self::$errorMessage) {
            return '
            <div class="toast-container position-fixed bottom-0 end-0 p-3 ">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <strong class="me-auto">' . self::$errorTitle . '</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-bg-danger">'
                . self::$errorMessage .
                '</div>
            </div>
            </div>';
        }
        return null;
    }
}
