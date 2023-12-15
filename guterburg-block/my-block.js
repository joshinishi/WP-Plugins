wp.blocks.registerBlockType('gutenberg/border-box', {
    title: 'Border Box',
    icon: 'embed-generic',
    category: 'common',
    attributes: {
        content: { type: 'string', source: 'meta', meta: 'content' },
        color: { type: 'string' }
    },
    edit: function(props) {
        function updateContent(event) {
            props.setAttributes({ content: event.target.value });
        }

        function updateColor(value) {
            props.setAttributes({ color: value.hex });
        }
        return wp.element.createElement(
            "div",
            null,
            wp.element.createElement(
                "h3",
                null,
                "Border Box"
            ),
            wp.element.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
            wp.element.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
        );
    },
    save: function(props) {
        // Save post meta using REST API
        
        var request = new XMLHttpRequest();
        request.open('POST', wpApiSettings.root + 'wp/v2/posts/' + wpApiSettings.postId, true);
        request.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
        request.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        request.send(JSON.stringify({
            meta: {
                content: props.attributes.content,
                color: props.attributes.color
            }
        }));

        return wp.element.createElement(
            "h3",
            { style: { border: `5px solid ${props.attributes.color}` } },
            props.attributes.content
        );      
    }
});
