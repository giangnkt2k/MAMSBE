module.exports = {
    testRegex: 'resources/js/tests/.*.spec.js$',
    moduleNameMapper: {
      "^@/(.*)$": "<rootDir>/resources/js/$1"
    },
    moduleFileExtensions: ['js', 'json', 'vue'],
    transform: {
      '^.+\\.js$': '<rootDir>/node_modules/babel-jest',
      '.*\\.(vue)$': '<rootDir>/node_modules/vue-jest',
      "^.+\\.(css|styl|less|sass|scss|png|jpg|ttf|woff|woff2)$": "jest-transform-stub"
    },
    snapshotSerializers: ['jest-serializer-vue'],
    collectCoverageFrom: [
      'resources/js/**/*.{js,jsx,ts,tsx,vue}',
    ],
    collectCoverage: false,
    coverageReporters: ['html', 'lcov', 'text-summary'],
    coverageDirectory: './coverage',
    testEnvironment: "jsdom",
    setupFiles: ['<rootDir>/resources/js/tests/setup.js'],
    testURL: "http://127.0.0.1:8001/",
    setupFilesAfterEnv: ['<rootDir>/resources/js/tests/setup.js'],
  }
