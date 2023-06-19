<?php
class TemplateRenderer
{
    private $message;
    private $msgTitle;
    private $errorMessage;
    private $errorTitle;
    private $navbarContent;
    private $modalContent;
    private $bodyContent;
    private $sideBarContent;
    private $title;

    public function render($title = "Document", $bodyContent = null, $sidebarContent = null): string
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

            <title>
                <?php echo $title; ?>
            </title>
        </head>

        <body class="custom-bc">
            <?php echo $this->renderNavbar() ?>
            <?php echo $this->renderMessage(); ?>
            <?php echo $this->renderModal(); ?>
            <?php echo $this->errorMessage ? $this->renderErrorMessage() : null; ?>
            <div class="container">
                <?php echo $this->sideBarContent ? $this->renderSideBar() : null; ?>
                <?php echo $this->bodyContent ? $this->renderBodyContent() : null; ?>
            </div>
            <script type="module" src="../dist/app-bundle.js"></script>
        </body>

        </html>
        <?php
        return ob_get_clean();
    }

    public function renderBodyContent(): string
    {
        if ($this->bodyContent) {
            return '
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                ' . $this->bodyContent . '
            </div>
            ';
        }
        return '';
    }

    public function setSidebarContent($sideBarContent): void
    {
        $this->sideBarContent = $sideBarContent;
    }

    public function renderSideBar(): mixed
    {
        if ($this->sideBarContent) {
            return '
            <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="staticBackdropLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>'
                . $this->sideBarContent .
                '</div>
                </div>
            </div>
            ';
        }
        return null;
    }

    public function setMessage($msgTitle, $message): void
    {
        $this->msgTitle = $msgTitle;
        $this->message = $message;
    }

    public function setBodyContent($bodyContent)
    {
        $this->bodyContent = $bodyContent;
    }

    public function setNavbarContent($navbarContent): void
    {
        $this->navbarContent = $navbarContent;
    }

    public function setModalContent($modalContent): void
    {
        $this->modalContent = $modalContent;
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
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">' . $this->msgTitle . '</strong>
                        <small>Now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-bg-primary">' . $this->message . '</div>
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

    private function renderModal()
    {
        if ($this->modalContent) {
            $modal = new Modal($this->modalContent);
            return $modal->render();
        }
    }

    private function renderErrorMessage()
    {
        if ($this->errorMessage) {
            return '
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header text-bg-danger">
                        <strong class="me-auto">' . $this->errorTitle . '</strong>
                        <small>Now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">' . $this->errorMessage . '</div>
                </div>
            </div>
            ';
        }
        return null;
    }
}