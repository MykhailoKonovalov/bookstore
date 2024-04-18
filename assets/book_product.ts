import BookProductController from "./controllers/admin/book_product_controller";
import {app} from './bootstrap.js';

app.register('bookProduct', BookProductController);