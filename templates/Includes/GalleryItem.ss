<div class="gallery__item">
    <% if $Image %>
        $Image.CroppedImage(480,375)
    <% end_if %>
    <p class="gallery__item-caption">
        <% if $Caption %>
            $Caption
        <% else %>
            $Image.Title
        <% end_if %>
    </p>
</div>
