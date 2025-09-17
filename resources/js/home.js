import { tns } from "tiny-slider";
import "./sliders";

const monthSlider = tns({
  container: '.trips-month-slider',
  nav: false,
  controlsContainer: '.trips-month-slider-controls',
  autoplay: true,
  autoplayButtonOutput: false
})