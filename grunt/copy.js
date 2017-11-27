module.exports = function (grunt) { 
    
    var namespace = grunt.option('namespace');
    
    return {
        
        build_namespace: {
            
            expand: true,
            cwd: './', 
            src: ['**/*'], 
            dest: './build/WPObjects',
            
            options: {
                process: function (content, srcpath) {
                    var needed = namespace + "\\WPObjects\\";
                    var replacer = "WPObjects\\";
                    content_replacement = content_replacement.replace( new RegExp(replacer, "gi"), needed);
                    
                    return content_replacement;
                }
            }
            
        },
        
    };
    
};