import data from "./blocks.json";

(function (wp) {

    const { registerBlockType } = wp.blocks;
    const { __ } = wp.i18n;
    const { Component, Fragment } = wp.element;
    
    const { 
        InspectorControls,
        MediaUploadCheck,
        MediaUpload,
        URLInput,
        useBlockProps,
        RichText,
        InnerBlocks,
    } = wp.blockEditor;
    
    const { 
        Button, 
        TextControl, 
        NumberControl, 
        RangeControl, 
        TextareaControl, 
        SelectControl, 
        ResponsiveWrapper, 
        Spinner, 
        BaseControl,
        CheckboxControl
    } = wp.components;

    const el = wp.element.createElement;

    var blocks = [];
    var i = 0;

    class BlockGenerator {
        constructor(data) {

            if(!data) {
                console.error("BlockGenerator: Unable to find blocks JSON");
                return;
            }
    
            this.registerBlocks(data.blocks);
        }
    
        registerBlocks(blocks, pathPrefix = "", isChild = false) {
            blocks.forEach(blockData => {
                
                var block = require(pathPrefix + blockData.path + "block.json");
                block.path = blockData.path;
                block.isChild = isChild;
    
                this.registerBlock(block);
    
                if(typeof block.children !== 'undefined' && block.children.length > 0) {
                    // Register all children blocks with isChild set to true
                    this.registerBlocks(block.children, pathPrefix + block.path, true);
                }
            });
        }
    
        registerBlock(block) {
    
            block.name = block.categ + "/" + block.slug;

            if(typeof block.parent != "undefined") {
                block.parentName = (typeof block.parent != "undefined") ? block.categ + '/' + block.parent : '';
            }
            
            const renderJSX = block.render == "JSX";
    
            registerBlockType(block.name, {
                title: block.title,
                description: block.desc,
                icon: block.icon,
                parent: block.parentName,
                category: block.categ,
    
                attributes: block.attrs,
        
                edit: () => {     
                    return new CustomEdit();
                },
        
                save: () => { 
                    if(!block.usesInner)
                        return null;
                    else {
                        return <InnerBlocks.Content />
                    } 
                }
            });
    
            blocks.push(block);
        }
    }

    var block = null;

    class CustomEdit extends Component { 

        render() {

            // console.log("generating Edit of " + block.name);

            const { 
                attributes, 
                setAttributes, 
                className, 
                clientId,
                name
            } = this.props;

            block = blocks.find(block => {
                return block.name === name;
            })

            if(typeof block === "undefined") return __("Bloco " + name +  " indisponível");

            const { category, startCollapsed } = data;

            var collapseClass = "accordion-collapse collapse";
            collapseClass += (startCollapsed) ? "" : " show";

            var buttonClass = "accordion-button";
            buttonClass += (startCollapsed) ? " collapsed" : "";
            
            const edit = block.edit;

            const icon = "d-block m-0 mt-auto me-2 fa-sm block-icon dashicons dashicons-" + block.icon;

            this.count = 0;

            const blockElements = [];

            
            if(typeof edit !== "undefined") {
                edit.forEach(element => {
                    if(element.tag == "title") {
                        blockElements.push(this.generateTitle(element));
                    }
                    else if(element.tag == "input") {  
                        blockElements.push(this.generateInput(element));
                    }
                });
            }

            const blockBody = 
                el (
                    'div',
                    {
                        className: "accordion-body " + className
                    },
                    blockElements 
                );
            
            const blockEdit =
                <div 
                class="accordion"  
                id={'wrap-' + clientId}>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id={'header-' + clientId}>

                            <button 
                            class= { buttonClass } 
                            type="button" 
                            data-toggle="collapse" 
                            data-target={'#body-' + clientId} 
                            aria-expanded= { !startCollapsed }
                            aria-controls={'body-' + clientId}>
                                <span
                                class="d-block">
                                    <span class={ icon }></span>
                                    { block.title }
                                    <small class="category-title">
                                        { category }
                                        {/* { block.desc } */}
                                    </small>
                                </span>
                            </button>
                        </h2>

                        <div 
                        id={'body-' + clientId} 
                        class={ collapseClass } 
                        aria-labelledby={'header-' + clientId} 
                        data-parent={'#wrap-' + clientId}>
                            { blockBody }
                        </div>
                    </div>
                </div>;

            return blockEdit;
        }

        generateTitle(element) {
            const tag = element.tag;
            const title = element.title;
            
            if(tag != "title") return null;
            if(title.length == 0) return null;

            var classes = "hr-title";

            if(this.count == 0) classes += " mt-0";

            this.count++;

            return <Fragment>
                    <h4 class="hr-title">
                        { title }
                    </h4>
                    <hr />
                </Fragment>;
        }

        generateInput(element) {
            var tag = element.tag;
            var type = element.type;
            var attr = element.attr;
            var label = element.label;
            var help = element.help;
            var tagName = element.tagName;


            if(typeof tag != "undefined" && tag != "input") 
                return null;
            if(typeof label != "undefined" && label.length == 0) 
                return null;
            if(typeof attr != "undefined" && attr.length == 0) 
                return null;


            const { 
                attributes, 
                setAttributes
            } = this.props;
            
            const value = attributes[attr] ?? element.value;

            var inputContent = <Fragment></Fragment>;

            if(type == "text") {
                inputContent =
                    <Fragment>
                        <TextControl
                            label={ label }
                            help={ help }
                            value={ value }
                            onChange={ (value) => {
                                setAttributes({[attr]: value});
                            } }
                        >
                        </TextControl>
                    </Fragment>;
            }
            else if(type == "number") {

                var step = element.step;
                if(typeof step == "undefined") step = 1;
                var min = element.min;
                if(typeof min == "undefined") min = 0;
                var max = element.max;
                if(typeof max == "undefined") max = 100;

                inputContent =
                <Fragment>
                    <TextControl
                        type="number"
                        label={ label }
                        help={ help }
                        value={ value }
                        onChange={ (value) => {
                            setAttributes({[attr]: value});
                        } }
                        step={ step }
                        min={ min }
                        max={ max }
                    >
                    </TextControl>
                </Fragment>;

            }
            else if(type == "range") {

                var step = element.step;
                if(typeof step == "undefined") step = 1;
                var min = element.min;
                if(typeof min == "undefined") min = 0;
                var max = element.max;
                if(typeof max == "undefined") max = 100;
                
                var withInputField = element.withInputField;
                if(typeof withInputField == "undefined") withInputField = true;

                var beforeIcon = element.beforeIcon;
                var afterIcon = element.afterIcon;
                
                var marks = element.marks;
                if(typeof marks == "undefined") {
                    marks = [
                        {
                            value: min,
                            label: min.toString()
                        },
                        {
                            value: max,
                            label: max.toString()
                        },
                    ];
                }

                inputContent =
                <Fragment>
                    <RangeControl
                        type="number"
                        label={ label }
                        help={ help }
                        value={ value }
                        onChange={ (value) => {
                            setAttributes({[attr]: value});
                        } }
                        step={ step }
                        min={ min }
                        max={ max }
                        withInputField={ withInputField }
                        beforeIcon={ beforeIcon }
                        afterIcon={ afterIcon }
                        marks={ marks }
                    >
                    </RangeControl>
                </Fragment>;

            }
            else if(type == "rich") {

                inputContent = 
                    <Fragment>
                        <BaseControl
                        label={ label }
                        help={ help }>
                            &nbsp;<i class="bi bi-pencil-fill"></i>
                            <RichText
                                tagName={ tagName }
                                value={ value }
                                onChange={ (value) => {
                                    setAttributes({[attr]: value});
                                } }
                            />
                        </BaseControl>
                    </Fragment>;
            }
            else if(type == "textarea") {
                inputContent = 
                    <TextareaControl
                        label={ label }
                        help={ help }
                        value={ value }
                        onChange={ (value) => {
                            setAttributes({[attr]: value});
                        } }
                    >
                    </TextareaControl>;
            }
            else if(type == "image") {
                const imageAttr = { 
                    'value': value, 
                    'name': "background" ,
                    'attr': attr
                };

                const imageMaxHeight = element.maxHeight ?? "300px";

                var removeEvent = () => {
                    setAttributes({[attr]: undefined});
                };

                inputContent = 
                    <Fragment>
                        <BaseControl
                        label={ label }>
                        </BaseControl>
                        <MediaUpload
                            type="image"
                            value={ value }
                            onSelect={ (media) => {
                                setAttributes({[attr]: media.url});
                            } }
                            render={({ open }) => this.getImageButton(open, imageAttr, imageMaxHeight, removeEvent)}
                        />
                    </Fragment>;
            }
            else if(type == "url") {
                inputContent = 
                    <Fragment>
                        <URLInput
                            label={ label }
                            value={ value }  
                            onChange={ (value) => {
                                setAttributes({[attr]: value});
                            } }
                        >
                        </URLInput>
                    </Fragment>
            }
            else if(type == "check") {
                inputContent = 
                    <Fragment>
                        <CheckboxControl
                            label={ label }
                            help={ help }
                            checked={ value }  
                            onChange={ (value) => {
                                setAttributes({[attr]: value});
                            } }
                        >
                        </CheckboxControl>
                    </Fragment>
            }
            else if(type=="select" && typeof element.options !== "undefined" ) {
                const options = element.options;
                inputContent = 
                    <Fragment>
                        <SelectControl
                        label={ label }
                        help={ help }
                        value={ value } 
                        options={ options }
                        onChange={ (value) => {
                            setAttributes({[attr]: value});
                        } }
                        />
                    </Fragment>;
            }
            else if(type=="inner") {
                // const blocks = [ 'emertechblock/stripe' ];
                const blocks = element.blocks;
                const template = element.template ?? [];
                var templateLock = (element.template !== '') ? element.templateLock ?? "all" : "false";

                inputContent = 
                    <Fragment>
                        <BaseControl
                        label={ label }
                        help={ help }>
                            <InnerBlocks
                                allowedBlocks={ blocks }
                            // template={ template }
                            // templateLock={ templateLock }
                            />
                        </BaseControl>
                    </Fragment>;
            }

            return inputContent;
        }
        
        getImageButton (openEvent, attr, imageMaxHeight, removeEvent = null) {
            if (attr['value']) {

                return (
                    [
                        <img
                        style={{ maxHeight: imageMaxHeight }}
                        src={attr['value']}
                        onClick={openEvent}
                        className={block.categ + "_" + block.name + "_" + attr['name'] + " mb-2"}
                        />,
                        <div className="button-container">
                            <Button
                                onClick={openEvent}
                                className="button button-large select-image-btn"
                            >
                                { this.getSelectImageText() }
                            </Button>
                            <Button
                                onClick={ removeEvent }
                                isDestructive={true}
                            >
                                { this.getRemoveImageText() }
                            </Button>
                        </div>
                    ]
                );
            }
            else {
                return (
                    <div className="button-container">
                        <Button
                            onClick={openEvent}
                            className="button button-large"
                        >
                            { this.getSelectImageText() }
                        </Button>
                    </div>
                );
            }
        }

        getSelectImageText() {
            return __("Selecione uma Imagem");
        }

        getRemoveImageText() {
            return __("Remover Imagem");
        }
    }

    new BlockGenerator(data);

}(window.wp)); 