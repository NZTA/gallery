import React from 'react';

export default class CarouselModal extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      index: props.index
    };

    this.handlePrev = this.handlePrev.bind(this);
    this.handleNext = this.handleNext.bind(this);
  }

  render() {
    return (
      <div className="carousel-modal">
        <a
          className="carousel-modal__close"
          onClick={this.props.handleClose}
        >
          <img src="/gallery/icons/close.svg" />
        </a>
        {this.renderPrev()}
        {this.renderNext()}
        {this.renderCarousel()}
      </div>
    );
  }

  /**
   * Helper to render the previous button based on whether the user can
   * navigate to a previous gallery image.
   *
   * @return {String|null}
   */
  renderPrev() {
    let prevIndex = this.state.index - 1;

    return (prevIndex >= 0)
      ? (<a className="carousel-modal__control carousel-modal__control--prev" onClick={this.handlePrev}></a>)
      : null;
  }

  /**
   * Helper to render the next button based on whether the user can navigate
   * to the next gallery image.
   *
   * @return {String|null}
   */
  renderNext() {
    let nextIndex = this.state.index + 1;

    return (nextIndex <= this.props.items.length - 1)
      ? (<a className="carousel-modal__control carousel-modal__control--next" onClick={this.handleNext}></a>)
      : null;
  }

  /**
   * Helper to render the currently selected gallery image.
   *
   * @return {String}
   */
  renderCarousel() {
    return this.props.items.map((item, i) => {
      return (i === this.state.index)
        ? (
          <div className="carousel-modal__item" key={`carousel-item-${item.id}`}>
            <img src={item.url} className="carousel-modal__image" />
            <p className="carousel-modal__caption">{item.caption}</p>
          </div>
        )
        : null;
    });
  }

  /**
   * Helper to navigate the user to the previous gallery image.
   *
   * @return void
   */
  handlePrev() {
    this.setState({
      index: this.state.index - 1
    });
  }

  /**
   * Helper to navigate the user to the next gallery image.
   *
   * @return void
   */
  handleNext() {
    this.setState({
      index: this.state.index + 1
    });
  }
}
