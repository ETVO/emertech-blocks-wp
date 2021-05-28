
const { Component, Fragment } = wp.element;

export default class SaveDisplay extends Component {
    render() {

        console.log("SaveDisplay");
        
        const { 
            attributes, 
            setAttributes, 
            className, 
            clientId,
            name
        } = this.props;


        const {
            imageUrl,
            title,
            text,
            btnText,
            btnUrl,
            btnNewTab,
            alignStyle
        } = attributes;
        
        var content_col_class = " order-last text-end";
        if(alignStyle == "left") 
            content_col_class = " order-first text-start";

        var btn_target = (btnNewTab) ? "_blank": "_self";

        const ebDisplay = 
            <section class="eb-display bg-dark text-light p-5">
                <div class="container px-4">
                    <div class="row m-auto">
                        <div class="col-lg-6">
                            <div class="image">
                                <img src={ imageUrl } alt="" class="img-fluid rounded" />
                            </div>
                        </div>
                        <div class={ "col-lg-6 py-4" + content_col_class }>
                            <div class="content">
                                <div class="title text-uppercase">
                                    <h2>
                                        { title } 
                                    </h2>
                                </div>

                                <div class="text">
                                    <p>
                                        { text }  
                                    </p>
                                </div>

                                <div class="action text-uppercase ">
                                    <a 
                                    class="eb-link text-primary fs-5" 
                                    href={ btnUrl } 
                                    target={ btn_target }>
                                        { btnText }  
                                    </a>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </section>

        return ebDisplay;
    }
} 