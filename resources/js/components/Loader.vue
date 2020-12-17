<template>
  <div class="loader">
    <div class="loader__item">
      <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
            width="200mm" height="200mm" viewBox="0 0 200 200" version="1.1"
            id="loader">
        <defs id="defs2" />
        <metadata id="metadata5"></metadata>
        <g id="layer1" transform="translate(0,-97)" style="display:inline">
          <path
            style="display:inline;opacity:1;fill:none;fill-opacity:1;stroke:#333333;stroke-width:13;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
            d="m 123.98243,130.25038 c -21.99097,18.96099 -43.981933,37.92197 -65.9729,56.88296 6.350873,0.0104 12.701747,0.0209 19.05262,0.0313 v 38.01988 m 46.92028,-94.93414 65.9729,56.88296 c -6.35087,0.0104 -12.70175,0.0209 -19.05262,0.0313 v 76.52149"
            id="up" />
          <path
            style="opacity:1;fill:#fafbff;fill-opacity:1;stroke:#333333;stroke-width:13;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
            d="M 10.044666,202.08921 C 34.094254,181.35326 58.143841,160.6173 82.193429,139.88135 106.243,160.6173 130.29258,181.35326 154.34215,202.08921 147.39676,202.10061 140.45137,202.11201 133.50598,202.12341 133.50598,222.55803 133.50598,242.99265 133.50598,263.42727 99.297605,263.42725 65.08923,263.42727 30.880855,263.42727 30.880869,242.99265 30.880825,222.55803 30.880855,202.12341 23.935459,202.11201 16.990062,202.10061 10.044666,202.08921 Z"
            id="home" />
        </g>
        <g id="layer2">
          <path
            style="display:inline;opacity:1;fill:none;fill-opacity:1;stroke:#333333;stroke-width:13;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
            d="M 93.717806,114.94159 C 93.930311,107.78149 94.142816,100.62138 94.355321,93.461281 101.41239,93.670731 108.46946,93.880181 115.52653,94.089631"
            id="arrow" />
          <circle
            style="opacity:1;fill:none;fill-opacity:1;stroke:#333333;stroke-width:13;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:145;stroke-opacity:1"
            id="circle"
            transform="rotate(-50.354444)"
            cx="-40.795528"
            cy="140.6032"
            r="28.636374" />
        </g>
      </svg>
    </div>
    <p class="loading__text">
      <slot>読込中...</slot>
    </p>
  </div>
</template>