import Carousel from '@stimulus-components/carousel'

export default class CarouselController extends Carousel {
    get defaultOptions() {
        return {
            spaceBetween: 10,
            slidesPerView: 1,
            autoHeight: true,
            loop: true,
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                990: {
                    slidesPerView: 3,
                },
                1096: {
                    slidesPerView: 4,
                },
            },
        };
    }
}