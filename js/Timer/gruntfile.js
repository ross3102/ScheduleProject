module.exports = function (grunt) {

    grunt.initConfig({
        watch: {
            files: ['countdown-timer.js'],
            tasks: ['uglify:prod']
        },
        uglify: {
            prod: {
                files: {
                    'countdown-timer.min.js': ['countdown-timer.js']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify:prod']);

};