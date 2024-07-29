import React from "react";
import CarouselModal from "./CarouselModal";

export default class Gallery extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            active: false,
            index: 0,
        };

        this.handleClick = this.handleClick.bind(this);
    }

    render() {
        return (
            <div className="gallery__items">
                {this.props.items.length > 0 ? this.renderThumbnails() : null}
                {this.renderCarouselModal()}
            </div>
        );
    }

    /**
     * Helper to render all the gallery thumbnails that open the CarouselModal
     * when clicked.
     *
     * @return {String}
     */
    renderThumbnails() {
        return this.props.items.map(
            (item, i) =>
                <div
                    key={`gallery-thumbnail-${item.id}`}
                    className="gallery__item"
                    onClick={this.handleClick.bind(null, i)}
                >
                    <div className="gallery__item-img">
                        {this.renderThumbnail(item)}
                    </div>
                    <p className="gallery__item-caption">
                        {item.thumbnailCaption}
                    </p>
                </div>
        );
    }

    /**
     * Basic helper to render a single thumbnail image for specified gallery item.
     *
     * @param {Object} item
     *
     * @return {String}
     */
    renderThumbnail(item) {
        return item.thumbnail ? <img src={item.thumbnail} /> : null;
    }

    /**
     * Helper to render the CarouselModal if it should be active.
     *
     * @return {String|null}
     */
    renderCarouselModal() {
        return this.state.active ? (
            <CarouselModal
                items={this.props.items}
                index={this.state.index}
                handleClose={this.handleClick.bind(null, 0)}
            />
        ) : null;
    }

    /**
     * This handler is used to display the CarouselModal for the selected
     * gallery thumbnail image.
     *
     * @param {Integer} id
     * @param {Event} e
     *
     * @return void
     */
    handleClick(index, e) {
        e.preventDefault();

        this.setState({
            active: !this.state.active,
            index: index !== void 0 ? index : 0,
        });
    }
}
