import {Controller} from "@hotwired/stimulus";

export default class WishlistController extends Controller {
    static targets = ["addToWishlistButton", "removeFromWishlistButton"];
    static values = { bookSlug: String };

    async addToWishlist() {
        const bookSlug = this.bookSlugValue;

        try {
            const response = await fetch("/wishlist/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    bookSlug: bookSlug,
                }),
            });

            if (!response.ok) {
                throw new Error("Failed to add book to wishlist.");
            }

            const data = await response.json();

            this.toggleButtons(this.removeFromWishlistButtonTarget, this.addToWishlistButtonTarget);
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async removeFromWishlist() {
        const bookSlug = this.bookSlugValue;

        try {
            const response = await fetch(`/wishlist/remove/${bookSlug}`, {
                method: "DELETE",
            });

            if (!response.ok) {
                throw new Error("Failed to remove book from wishlist.");
            }

            const data = await response.json();
            this.toggleButtons(this.addToWishlistButtonTarget, this.removeFromWishlistButtonTarget);
        } catch (error) {
            console.error("Error:", error);
        }
    }

    toggleButtons(showButton, hideButton) {
        showButton.classList.toggle('d-none');
        hideButton.classList.add('d-none');
    }

    toggleButtonsVisibility() {
        this.addToWishlistButtonTarget.classList.toggle("d-none");
        this.removeFromWishlistButtonTarget.classList.toggle("d-none");
    }
}