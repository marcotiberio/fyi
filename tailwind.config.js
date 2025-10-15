/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '*.php',
    'templates/**/*.{php,twig}',
    './Components/**/*.{php,twig}'
  ],
  theme: {
    borderRadius: {
      none: '0',
      DEFAULT: '25px'
    },
    borderWidth: {
      DEFAULT: '1px',
      0: '0',
      2: '2px',
      3: '3px'
    },
    colors: {
      white: '#fff',
      black: '#000',
      yellow: '#f5cc5a',
      blue: '#49a3d5',
      brown: '#a76d61',
      red: '#ff0000',
      grey: '#f9f9f9',
      darkgrey: '#333',
      beige: '#edecd9',
      acqua: '#51bad9',
      azulgrey: '#e6ecee',
      darkblue: '#001028',
      current: 'currentColor',
      transparent: 'transparent'
    },
    fontSize: {
      body: ['1.25rem'],
      button: ['1rem'],
      superTitle: ['4.375rem'],
      superSubtitle: ['1.875rem'],
      h1: ['4.875rem'],
      h2: ['2.375rem'],
      h3: ['1.25rem'],
      menu: ['1rem']
    },
    screens: {
      sm: '640px',
      md: '780px',
      lg: '1180px',
      xl: '1440px',
      max: '1920px'
    },
    extend: {
      aspectRatio: {
        '16/6': '16 / 6',
        '4/3': '4 / 3',
        '3/4': '3 / 4',
        '2/1': '2 / 1'
      },
      borderWidth: {
        DEFAULT: '1px',
        0: '0',
        2: '2px',
        3: '3px',
        4: '4px'
      },
      fontFamily: {
        sans: ['"FavoritLight"'],
        serif: ['"FavoritLight"']
      },
      spacing: {
        xs: '10px',
        sm: '20px',
        md: '30px',
        lg: '60px',
        xl: '80px',
        xxl: '100px'
      }
    }
  },
  plugins: []
}
