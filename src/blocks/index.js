/**
 * BLOCK: Famous Blog Block Page Grid
 */

// Import block dependencies and components
import classnames from 'classnames';
import edit from './edit';
import icons from '../icons/icons';
// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __, setLocaleData  } = wp.i18n;

// Extend component
const {Component} = wp.element;

// Register block controls
const {registerBlockType} = wp.blocks;

// Register alignments
const validAlignments = ['center', 'wide'];

export const name = 'core/latest-posts';

// Register the block
registerBlockType('post-layouts/pl-blog-templates', {
    title: __('Post Layouts'),
    description: __('Showcase your posts in grid and list layout with multiple templates availability.'),
    icon: icons.postlayoutsicn,
    category: 'post-layouts',
    keywords: [
        __('post'),
        __('grid'),
        __('list'),
    ],

    getEditWrapperProps(attributes) {
        const {align} = attributes;
        if (-1 !== validAlignments.indexOf(align)) {
            return {'data-align': align};
        }
    },

    edit,

    // Render via PHP
    save() {
        return null;
    },
});