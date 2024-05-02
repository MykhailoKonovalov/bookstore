import {app} from "./bootstrap.js";
import WishlistController from "./controllers/wishlist_controller";

app.register('wishlist', WishlistController);