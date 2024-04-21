import Carousel from '@stimulus-components/carousel'

export default class CarouselController extends Carousel {
    get defaultOptions() {
        return {
            spaceBetween: 20,
            slidesPerView: 3,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            }
        }
    }
}