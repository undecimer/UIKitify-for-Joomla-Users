# YOOtheme Pro UIkit Template Overrides

Modern template overrides for YOOtheme Pro using UIkit framework. This package provides a clean, consistent, and modern design for Joomla's user authentication and login interfaces.

## Features

- 🎨 Modern UIkit-based design
- 📱 Mobile-first responsive layouts
- 🔒 Enhanced user authentication templates
- 🎯 Optimized module positioning
- ♿ Improved accessibility
- 🔄 Consistent visual language

## Components Included

### User Component (`com_users`)
- Multi-Factor Authentication (MFA) templates
- User profile management
- Registration forms
- Login/Logout interfaces

### Login Module (`mod_login`)
- Flexible module positioning
- Compact design
- Consistent styling
- Responsive layouts

## Requirements

- Joomla 4.0+
- PHP 7.4+
- YOOtheme Pro template 3.0+
- UIkit framework (included with YOOtheme Pro)

## Installation

1. Download the latest release `pkg_yootheme_uikit_overrides.zip`
2. Go to Joomla Administrator → System → Install Extensions
3. Drag and drop the package or use the "Upload Package File" option
4. Install the package

## Key Features

### Design Principles
- Minimal custom CSS
- UIkit grid system integration
- Consistent spacing and margins
- Inline icons with reduced ratios
- Responsive form elements

### Technical Features
- Preserved Joomla template inheritance
- Maintained server-side validation
- Standard Joomla language strings
- Enhanced password strength validation
- Module position flexibility

## Structure

```
pkg_yootheme_uikit_overrides/
├── packages/
│   ├── tpl_yootheme_users/
│   │   └── (com_users overrides)
│   └── tpl_yootheme_login/
│       └── (mod_login overrides)
├── pkg_yootheme_uikit_overrides.xml
└── pkg_script.php
```

## Customization

The template overrides follow YOOtheme Pro's styling conventions. You can customize the appearance through:

1. YOOtheme Pro's Style Customizer
2. Template override modifications
3. Custom UIkit theme variables
4. Additional CSS classes

## Best Practices

- Use UIkit's built-in classes when possible
- Maintain mobile-first approach
- Keep overrides minimal and focused
- Follow Joomla's MVC pattern
- Test across different module positions

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

MIT License. See [LICENSE](LICENSE) for more information.

## Support

- [Documentation](https://your-documentation-url.com)
- [Issue Tracker](https://your-issue-tracker-url.com)
- [Support Forum](https://your-support-forum-url.com)

## Credits

- Built for [YOOtheme Pro](https://yootheme.com/page-builder)
- Powered by [UIkit](https://getuikit.com/)
- Created for [Joomla CMS](https://www.joomla.org/)

## Changelog

### 1.0.0 (2024-01)
- Initial release
- Modern UIkit styling for user authentication
- Responsive login module templates
- MFA template improvements
- Profile management enhancements
