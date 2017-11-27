module.exports = function(grunt) {
    
    grunt.option('namespace', 'area');
    
    require('time-grunt')(grunt);
    
    require('load-grunt-config')(grunt, {
        jitGrunt: true
    });
    
};