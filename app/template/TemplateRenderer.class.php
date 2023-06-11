<?php
class TemplateRenderer
{
    private $message;
    private $msgTitle;
    private $errorMessage;
    private $errorTitle;
    private $navbarContent;

    public function render($title = "Document", $content = null, $sidebarContent = null)
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
            <?php echo $this->renderNavbar() ?>
            <?php echo $this->renderMessage(); ?>
            <?php echo $this->errorMessage ? $this->renderErrorMessage() : null; ?>
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

    public function setMessage($msgTitle, $message): void
    {
        $this->msgTitle = $msgTitle;
        $this->message = $message;
    }

    public function setNavbarContent($navbarContent): void
    {
        $this->navbarContent = $navbarContent;
    }

    public function setError($errorTitle, $errorMessage): void
    {
        $this->errorTitle = $errorTitle;
        $this->errorMessage = $errorMessage;
    }

    private function renderMessage()
    {
        if ($this->message) {
            return '
            <div class="toast-container position-fixed bottom-0 end-0 p-3 ">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                    <strong class="me-auto">' . $this->msgTitle . '</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-bg-primary">'
                . $this->message .
                '</div>
                </div>
                </div>
            ';
        }
        return null;
    }

    private function renderNavbar()
    {
        if ($this->navbarContent) {
            return '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ps-4 text-capitalize">' . $this->navbarContent . '</nav>';
        }
        return null;
    }

    private function renderErrorMessage()
    {
        if ($this->errorMessage) {
            return '
        <div class="toast-container position-fixed bottom-0 end-0 p-3 ">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">' . $this->errorTitle . '</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-bg-danger">'
                . $this->errorMessage .
                '</div>
            </div>
        </div>';
        }
        return null;
    }
}
