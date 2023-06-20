<?php
class CustomCard
{
    private $title;
    private $content;
    private $cardBackgroundColor = "#fff";
    private $iconBackgroundColor = "#ddd";
    private $icon;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    private function setBackgroundColor($cardBackgroundColor): void
    {
        $this->cardBackgroundColor = $cardBackgroundColor;
    }

    public function setIconBackgroundColor($iconBackgroundColor): void
    {
        $this->iconBackgroundColor = $iconBackgroundColor;
    }

    private function renderIcon(): mixed
    {
        $iconBackgroundColor = $this->iconBackgroundColor;
        if (isset($this->icon)) {
            return <<<HTML
            <span class="material-icons-outlined rounded-circle" style="background-color:$iconBackgroundColor; font-size:3rem">
                $this->icon
            </span>
            HTML;
        }
        return null;
    }

    public function __invoke(): string
    {
        $cardTitle = $this->title;
        $content = $this->content;
        $cardBackgroundColor = $this->cardBackgroundColor;
        $icon = $this->renderIcon();

        $iconHtml = '';
        if ($icon !== null) {
            $iconHtml = $icon;
        }

        return <<<HTML
    <div class="global-data-card m-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body  " style="background-color: $cardBackgroundColor;">
                <div class="d-flex gap-5 align-items-center">
                    <h5 class="card-title">$cardTitle</h5>
                    $iconHtml
                </div>
                <h6 class="card-subtitle mb-2 text-muted">$content</h6>
            </div>
        </div>
    </div>
    HTML;
    }

}