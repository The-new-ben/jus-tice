(function (wp) {
    const registerPlugin = wp.plugins.registerPlugin;
    const PluginSidebar = wp.editPost.PluginSidebar;
    const PluginSidebarMoreMenuItem = wp.editPost.PluginSidebarMoreMenuItem;
    const PanelBody = wp.components.PanelBody;
    const TextControl = wp.components.TextControl;
    const Button = wp.components.Button;
    const useState = wp.element.useState;

    function Panel() {
        const state = useState('');
        const prompt = state[0];
        const setPrompt = state[1];
        const listState = useState([]);
        const list = listState[0];
        const setList = listState[1];

        function ask() {
            fetch('/ai/v1/suggest', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ prompt: prompt })
            }).then(function (r) {
                return r.json();
            }).then(function (data) {
                const items = data.suggestions ? data.suggestions : [];
                setList(items);
            });
        }

        return wp.element.createElement(
            PluginSidebar,
            { name: 'seo-aio-ui', title: 'SEO AIO' },
            wp.element.createElement(
                PanelBody,
                null,
                wp.element.createElement(TextControl, {
                    value: prompt,
                    onChange: setPrompt
                }),
                wp.element.createElement(Button, { variant: 'primary', onClick: ask }, 'Ask'),
                wp.element.createElement('ul', null, list.map(function (s, i) {
                    return wp.element.createElement('li', { key: i }, s);
                }))
            )
        );
    }

    function MenuItem() {
        return wp.element.createElement(
            PluginSidebarMoreMenuItem,
            { target: 'seo-aio-ui' },
            'SEO AIO'
        );
    }

    function Root() {
        return wp.element.createElement(
            wp.element.Fragment,
            null,
            wp.element.createElement(MenuItem),
            wp.element.createElement(Panel)
        );
    }

    registerPlugin('seo-aio-ui', { render: Root });
})(window.wp);
