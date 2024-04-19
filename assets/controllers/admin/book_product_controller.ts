import {Controller} from "@hotwired/stimulus";

export default class BookProductController extends Controller {
    protected bookTypeFields: NodeListOf<Element>;

    protected price: NodeListOf<Element>;

    protected discount: NodeListOf<Element>;

    async connect() {
        this.bookTypeFields = document.querySelectorAll('.js-book-type');
        this.price = document.querySelectorAll('.js-price');
        this.discount = document.querySelectorAll('.js-discount-percent');
        this.discount.forEach(field => {
            field.addEventListener('keyup', this.calculateDiscountPrice.bind(this));
        });
        this.price.forEach(field => {
            field.addEventListener('keyup', this.calculateDiscountPrice.bind(this));
        });
        this.bookTypeFields.forEach(field => {
            field.addEventListener('change', this.toggleFormats.bind(this));
        });
    }

    calculateDiscountPrice(event: Event) {
        const target = event.target as HTMLFormElement;
        const form = target.closest('.form-widget-compound');
        const discountPrice: HTMLInputElement = form.querySelector('.js-discount-price');
        const price: HTMLInputElement = form.querySelector('.js-price');
        const discount: HTMLInputElement = form.querySelector('.js-discount-percent');

        const discountPriceValue: number = parseInt(price.value) * (1 - (parseInt(discount.value) / 100));

        discountPrice.value = discountPriceValue > 0 ? discountPriceValue.toFixed(2) : '0';
    }

    toggleFormats(event: Event) {
        const target = event.target as HTMLSelectElement;
        const form = target.closest('.form-widget-compound');
        const electronicFormats: HTMLFormElement = form.querySelector('.js-book-formats');
        const bookType = target.value;

        electronicFormats.style.display = bookType === 'paper' ? 'none' : 'block';
    }
}