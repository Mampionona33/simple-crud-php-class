<?php
class CustomCard
{
    private $title;
    private $content;
    private $cardBackgroundColor = "#fff";
    private $iconBackgroundColor = "#ddd";

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    private function setBackgroundColor($cardBackgroundColor): void
    {
        $this->cardBackgroundColor = $cardBackgroundColor;
    }

    private function setIconBackgroundColor($iconBackgroundColor): void
    {
        $this->iconBackgroundColor = $iconBackgroundColor;
    }

    public function __invoke(): string
    {
        $cardTitle = $this->title;
        $content = $this->content;
        $cardBackgroundColor = $this->cardBackgroundColor;
        $iconBackgroundColor = $this->iconBackgroundColor;

        return <<<HTML
        <div class="global-data-card">
            <div class="card border-0">
                <div class="card-body" style="background-color: $cardBackgroundColor;">
                    <div class="d-flex gap-5 align-items-center">
                        <h5 class="card-title">$cardTitle</h5>
                        <span class="material-icons-outlined rounded-circle p-2" style="background-color:$iconBackgroundColor">
                            people_alt
                        </span>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted">$content</h6>
                </div>
            </div>
        </div>
        HTML;
    }
}
