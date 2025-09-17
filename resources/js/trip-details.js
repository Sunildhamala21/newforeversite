import { Fancybox } from "@fancyapps/ui";
import { CategoryScale, Chart, LinearScale, LineController, LineElement, PointElement } from "chart.js";
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { tns } from "tiny-slider";

Fancybox.bind("[data-fancybox]", {});

Chart.register(CategoryScale);
Chart.register(LinearScale);
Chart.register(LineController);
Chart.register(LineElement);
Chart.register(PointElement);
Chart.register(ChartDataLabels);
window.Chart = Chart;

// sticky price box
const stickyPrice = document.querySelector('#sticky-price');
const asideIO = new IntersectionObserver(
  (entries, observer) => {
    if (!entries[0].isIntersecting) {
      stickyPrice.classList.add('lg:block');
    } else {
      stickyPrice.classList.remove('lg:block');
    };
  }, {}
);
asideIO.observe(document.querySelector('#aside-contents'));

// trip image slider
tns({
  container: '#hero-slider',
  controlsContainer: '.hero-slider-controls',
  navContainer: '#slider-nav',
  lazyload: true,
  autoplay: false,
  autoplayButtonOutput: false
})

// scrollspy
const tdb = document.querySelector('.tdb')
if (tdb) {
  const sections = document.querySelectorAll('.tds')
  const sectionScrollObserver = new IntersectionObserver((entries, observer) => {
    if (entries) {
      entries.forEach(entry => {
        const link = tdb.querySelector(`[href="#${entry.target.id}"]`)
        if (link != null) {
          if (entry.isIntersecting) {
            link.classList.add('bg-accent')
          } else {
            link.classList.remove('bg-accent')
          }
        }
      })
    }
  }, {
    rootMargin: "-19% 0px -80% 0px"
  })
  sections.forEach(section => {
    sectionScrollObserver.observe(section)
  })
}