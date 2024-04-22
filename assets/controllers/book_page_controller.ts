import {Controller} from "@hotwired/stimulus";

export default class BookPageController extends Controller {
    protected activeButton: Element;

    toggleActive(event) {
        this.activeButton = document.querySelector('#book-format.active');

        const clickedButton = event.currentTarget;
        const activeFormat = clickedButton.getAttribute('data-value');

        this.activeButton.classList.remove('active')

        clickedButton.classList.add('active');

        const productInfo = document.querySelectorAll('.product-info');

        productInfo.forEach(function (element) {
            if (element.getAttribute('data-value') == activeFormat) {
                element.classList.remove('d-none');
            } else {
                element.classList.add('d-none');
            }
        });
    }
}