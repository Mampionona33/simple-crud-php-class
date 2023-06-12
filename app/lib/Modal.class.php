<?php
class Modal{
    private $content;

    public function __construct(string $content){
        $this->content = $content;
    }

    public function setContent(string $content):void
    {
        $this->content = $content;
    }

    public function render():string{
    return '
    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                '.$this->content.'
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>';
    }
}