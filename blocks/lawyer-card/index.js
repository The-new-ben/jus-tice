const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { useSelect } = wp.data;
const { SelectControl } = wp.components;
const { createElement: el } = wp.element;

registerBlockType('aero/lawyer-card', {
    title: __('Lawyer Card', 'aero'),
    icon: 'id',
    category: 'widgets',
    attributes: { lawyerId: { type: 'number', default: 0 } },
    edit: ({ attributes, setAttributes }) => {
        const lawyers = useSelect(select => select('core').getEntityRecords('postType', 'lawyers', { per_page: -1 }), []);
        if (!lawyers) {
            return el('p', {}, __('Loading...', 'aero'));
        }
        const options = [{ label: __('Select a lawyer', 'aero'), value: 0 }];
        lawyers.forEach(lawyer => {
            options.push({ label: lawyer.title.rendered, value: lawyer.id });
        });
        return el(SelectControl, {
            label: __('Lawyer', 'aero'),
            value: attributes.lawyerId,
            options,
            onChange: value => setAttributes({ lawyerId: parseInt(value, 10) })
        });
    },
    save: () => null,
});
