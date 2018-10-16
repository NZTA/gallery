import React from 'react';
import ReactDOM from 'react-dom';

import Gallery from './components/Gallery';

document.addEventListener('DOMContentLoaded', () => {
  let el = document.querySelector('[data-react-gallery]');
  let items = (window.__galleryData !== void 0 && window.__galleryData.items !== void 0)
    ? window.__galleryData.items
    : [];

  if (el && items.length) {
    ReactDOM.render(
      <Gallery items={items} />,
      el
    );
  }
});
