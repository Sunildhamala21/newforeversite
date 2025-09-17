import Autoplay from 'embla-carousel-autoplay'
import EmblaCarousel from 'embla-carousel'
import { addDotBtnsAndClickHandlers } from './EmblaCarouselDotButtons'
import { addPrevNextBtnsClickHandlers } from './EmblaCarouselArrowButtons'

function initBannerSlider(rootNode, plugins = []) {
    const viewportNode = rootNode.querySelector('.embla__viewport')

    const prevBtnNode = rootNode.querySelector('.button-prev')
    const nextBtnNode = rootNode.querySelector('.button-next')
    const dotsNode = rootNode.querySelector('.dots')

    const options = {
        loop: false,
        slidesToScroll: 'auto'
    }

    const embla = EmblaCarousel(viewportNode, options, plugins)

    const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlers(
        embla,
        prevBtnNode,
        nextBtnNode
    )
    embla.on('destroy', removePrevNextBtnsClickHandlers)

    if (dotsNode) {
        const removeDotBtnsAndClickHandlers = addDotBtnsAndClickHandlers(
            embla,
            dotsNode
        )
        embla.on('destroy', removeDotBtnsAndClickHandlers)
    }

}

document.addEventListener('DOMContentLoaded', () => {
    const bannerSliders = document.querySelectorAll('.banner-slider')
    bannerSliders.forEach(el => initBannerSlider(el))
    const plugins = [Autoplay()]
    const reviewSliders = document.querySelectorAll('.reviews-slider')
    reviewSliders.forEach(el => initBannerSlider(el, plugins))
})