module.exports = function (grunt) { 
    
    var namespace = grunt.option('namespace');
    
    return {
        
        build_namespace: {
            
            expand: true,
            cwd: './', 
            src: [
                './AjaxController/**/*',
                './AssetsManager/**/*',
                './Data/**/*',
                './EventManager/**/*',
                './Factory/**/*',
                './FileSystem/**/*',
                './LessCompiler/**/*',
                './Loader/**/*',
                './Log/**/*',
                './Model/**/*',
                './Notice/**/*',
                './Page/**/*',
                './PostType/**/*',
                './Service/**/*',
                './View/**/*',
                './license.txt'
            ], 
            dest: './build/WPObjects',
            
            options: {
                process: function (content, srcpath) {
                    var content_replacement = content;
                    
                    JSregex = /\.js/g;
                    PHPregex = /\.php/g;
                    
                    if (PHPregex.exec(srcpath) !== null) {
                        
                        // PHP namespaces
                        var needed = namespace + '\\WPObjects\\';
                        var replacer = "WPObjects\\\\";
                        content_replacement = content_replacement.replace( new RegExp(replacer, "gi"), needed);
                        
                    } else if (JSregex.exec(srcpath) !== null) {
                        
                        // JS global varialbe
                        var needed = namespace;
                        var replacer = "MSP";
                        content_replacement = content_replacement.replace( new RegExp(replacer, "gi"), needed);
                        
                    }
                    
                    return content_replacement;
                }
            }
            
        }
        
    };
    
};