module.exports = function(grunt) {
    
    grunt.option('namespace', 'AREA');
    
    require('time-grunt')(grunt);
    
    require('load-grunt-config')(grunt, {
        jitGrunt: true
    });
    
};