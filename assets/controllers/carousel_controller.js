import Carousel from '@stimulus-components/carousel'

export default class CarouselController extends Carousel {
    get defaultOptions() {
        return {
            spaceBetween: 10,
            slidesPerView: 4,
            autoHeight: true,
            loop: true,
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            }
        }
    }
}