/**
 * Cold Transport Pro - Main JavaScript
 * 主题主JavaScript文件
 */

(function($) {
    'use strict';
    
    // 文档加载完成后执行
    $(document).ready(function() {
        
        // ===== 移动端菜单切换 =====
        var $menuToggle = $('.menu-toggle');
        var $primaryMenu = $('#primary-menu');
        
        $menuToggle.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $(this).toggleClass('active');
            $primaryMenu.toggleClass('active');
            
            // 更新ARIA属性
            var isExpanded = $(this).hasClass('active');
            $(this).attr('aria-expanded', isExpanded);
        });
        
        // 点击其他地方关闭菜单
        $(document).on('click', function(e) {
            if (!$menuToggle.is(e.target) && !$primaryMenu.is(e.target) && 
                $primaryMenu.has(e.target).length === 0) {
                $menuToggle.removeClass('active');
                $primaryMenu.removeClass('active');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
        
        // ===== 语言切换功能 =====
        var $languageBtn = $('.language-btn');
        var $languageDropdown = $('.language-dropdown');
        
        $languageBtn.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $languageDropdown.toggleClass('active');
            $(this).attr('aria-expanded', $languageDropdown.hasClass('active'));
        });
        
        // 点击其他地方关闭语言下拉
        $(document).on('click', function(e) {
            if (!$languageBtn.is(e.target) && !$languageDropdown.is(e.target) && 
                $languageDropdown.has(e.target).length === 0) {
                $languageDropdown.removeClass('active');
                $languageBtn.attr('aria-expanded', 'false');
            }
        });
        
        // ===== 搜索功能 =====
        var $searchToggle = $('.search-toggle');
        var $searchFormContainer = $('.search-form-container');
        
        $searchToggle.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $searchFormContainer.toggleClass('active');
            $(this).attr('aria-expanded', $searchFormContainer.hasClass('active'));
            
            // 如果搜索框显示，聚焦到搜索输入框
            if ($searchFormContainer.hasClass('active')) {
                setTimeout(function() {
                    $searchFormContainer.find('input[type="search"]').focus();
                }, 100);
            }
        });
        
        // ===== 头部滚动效果 =====
        var $header = $('.site-header');
        var lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            var scrollTop = $(this).scrollTop();
            
            // 添加滚动样式
            if (scrollTop > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            // 隐藏/显示头部（可选）
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // ===== 平滑滚动 =====
        $('a[href*="#"]')
            .not('[href="#"]')
            .not('[href="#0"]')
            .not('[data-no-smooth]')
            .on('click', function(e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                    location.hostname === this.hostname) {
                    
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    
                    if (target.length) {
                        e.preventDefault();
                        
                        $('html, body').animate({
                            scrollTop: target.offset().top - 80
                        }, 800, 'swing', function() {
                            // 更新URL（可选）
                            if (history.pushState) {
                                history.pushState(null, null, '#' + target.attr('id'));
                            } else {
                                location.hash = '#' + target.attr('id');
                            }
                        });
                    }
                }
            });
        
        // ===== 返回顶部按钮 =====
        var $backToTop = $('#back-to-top');
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 600) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        });
        
        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 800);
        });
        
        // ===== 图片懒加载 =====
        function lazyLoadImages() {
            if ('IntersectionObserver' in window) {
                var imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                            }
                            
                            if (img.dataset.srcset) {
                                img.srcset = img.dataset.srcset;
                            }
                            
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                $('img[data-src], img[data-srcset]').each(function() {
                    imageObserver.observe(this);
                });
            } else {
                // 不支持IntersectionObserver的备用方案
                $('img[data-src]').each(function() {
                    $(this).attr('src', $(this).data('src'));
                });
                
                $('img[data-srcset]').each(function() {
                    $(this).attr('srcset', $(this).data('srcset'));
                });
            }
        }
        
        // 初始化图片懒加载
        lazyLoadImages();
        
        // ===== 联系表单处理 =====
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var originalText = $submitBtn.text();
            
            // 表单验证
            var isValid = true;
            var $requiredFields = $form.find('[required]');
            
            $requiredFields.each(function() {
                var $field = $(this);
                if (!$field.val().trim()) {
                    $field.addClass('error');
                    isValid = false;
                } else {
                    $field.removeClass('error');
                }
            });
            
            if (!isValid) {
                // 显示错误信息
                $form.find('.form-error').remove();
                $form.prepend('<div class="form-error">请填写所有必填字段</div>');
                return;
            }
            
            // 禁用提交按钮
            $submitBtn.prop('disabled', true).text('发送中...');
            
            // 模拟AJAX提交（实际使用时替换为真实AJAX调用）
            setTimeout(function() {
                $submitBtn.prop('disabled', false).text(originalText);
                
                // 显示成功消息
                $form.find('.form-success, .form-error').remove();
                $form.prepend('<div class="form-success">消息发送成功！我们会尽快联系您。</div>');
                
                // 清空表单
                $form[0].reset();
                
                // 3秒后隐藏成功消息
                setTimeout(function() {
                    $form.find('.form-success').fadeOut();
                }, 3000);
                
            }, 2000);
        });
        
        // ===== 产品图片放大功能 =====
        $('.product-image img').on('click', function() {
            var $img = $(this);
            var src = $img.attr('src');
            
            // 创建模态框
            var $modal = $('<div class="image-modal">')
                .html('<div class="modal-content"><img src="' + src + '" alt=""></div>')
                .appendTo('body');
            
            $modal.on('click', function(e) {
                if (e.target === this) {
                    $modal.remove();
                }
            });
            
            // ESC键关闭
            $(document).on('keyup', function(e) {
                if (e.key === 'Escape' && $modal.length) {
                    $modal.remove();
                    $(document).off('keyup');
                }
            });
        });
        
        // ===== 滚动动画 =====
        function initScrollAnimations() {
            var $animatedElements = $('.fade-in, .slide-up');
            
            if ($animatedElements.length) {
                var animationObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animated');
                            animationObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                
                $animatedElements.each(function() {
                    animationObserver.observe(this);
                });
            }
        }
        
        // 初始化滚动动画
        initScrollAnimations();
        
        // ===== 多语言切换功能 =====
        $('.lang-option').on('click', function(e) {
            e.preventDefault();
            
            var lang = $(this).data('lang');
            var $currentLang = $('.current-lang');
            
            // 更新当前语言显示
            $currentLang.text(lang === 'zh' ? '中文' : 'English');
            
            // 隐藏下拉菜单
            $languageDropdown.removeClass('active');
            
            // 这里可以添加实际的语言切换逻辑
            // 例如：重定向到对应语言页面或使用AJAX加载翻译内容
            console.log('切换到语言:', lang);
            
            // 示例：显示切换提示
            var message = lang === 'zh' ? '已切换到中文' : 'Switched to English';
            showToast(message);
        });
        
        // ===== 工具函数：显示Toast消息 =====
        function showToast(message, type = 'success') {
            var $toast = $('<div class="toast-message toast-' + type + '">')
                .text(message)
                .appendTo('body');
            
            setTimeout(function() {
                $toast.addClass('show');
                
                setTimeout(function() {
                    $toast.removeClass('show');
                    setTimeout(function() {
                        $toast.remove();
                    }, 300);
                }, 3000);
            }, 100);
        }
        
        // ===== 浏览器兼容性检查 =====
        function checkBrowserCompatibility() {
            // 检查是否支持现代JavaScript特性
            if (typeof Promise === 'undefined' || 
                typeof Object.assign === 'undefined' ||
                typeof Array.from === 'undefined') {
                
                showToast('您的浏览器版本较旧，建议升级以获得更好的体验', 'warning');
            }
        }
        
        // 执行浏览器兼容性检查
        checkBrowserCompatibility();
        
        // ===== 性能监控 =====
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    var perfData = window.performance.timing;
                    var loadTime = perfData.loadEventEnd - perfData.navigationStart;
                    
                    if (loadTime > 3000) {
                        console.log('页面加载时间:', loadTime + 'ms');
                    }
                }, 0);
            });
        }
        
    }); // document.ready结束
    
    // 窗口调整大小时的重置功能
    $(window).on('resize', function() {
        // 重置菜单状态
        $('.menu-toggle').removeClass('active');
        $('#primary-menu').removeClass('active');
        
        // 关闭所有下拉菜单
        $('.language-dropdown, .search-form-container').removeClass('active');
    });
    
})(jQuery);

// ===== 全局错误处理 =====
window.addEventListener('error', function(e) {
    console.error('JavaScript错误:', e.error);
    // 这里可以添加错误上报逻辑
});

// ===== 离线状态检测 =====
window.addEventListener('online', function() {
    console.log('网络连接已恢复');
});

window.addEventListener('offline', function() {
    console.log('网络连接已断开');
});

// ===== Service Worker 注册（可选） =====
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('ServiceWorker 注册成功:', registration);
        }).catch(function(error) {
            console.log('ServiceWorker 注册失败:', error);
        });
    });
}
