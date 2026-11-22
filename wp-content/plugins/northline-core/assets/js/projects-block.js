/* global wp */
/** A native Gutenberg block without a webpack/Babel build step. */
(function (blocks, element, components, blockEditor, serverSideRender) {
  const el = element.createElement;
  blocks.registerBlockType('northline/project-grid', {
    apiVersion: 3,
    title: 'Northline / Project Grid',
    description: 'A live, server-rendered portfolio grid powered by WP_Query.',
    icon: 'building',
    category: 'widgets',
    attributes: { count: { type: 'number', default: 4 } },
    supports: { html: false, align: ['wide', 'full'] },
    edit: function (props) {
      return el(element.Fragment, {},
        el(blockEditor.InspectorControls, {},
          el(components.PanelBody, { title: 'Project display', initialOpen: true },
            el(components.RangeControl, {
              label: 'Maximum projects',
              min: 1,
              max: 12,
              value: props.attributes.count,
              onChange: function (count) { props.setAttributes({ count: count }); }
            })
          )
        ),
        el('div', blockEditor.useBlockProps(),
          el(serverSideRender, { block: 'northline/project-grid', attributes: props.attributes })
        )
      );
    },
    save: function () { return null; }
  });
})(wp.blocks, wp.element, wp.components, wp.blockEditor, wp.serverSideRender);
