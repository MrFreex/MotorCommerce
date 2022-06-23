interface Size {
    name : string,
    available : number | boolean,
    costChange : number
}

interface Variation {
    name : string,
    value : string
}

interface Product {
    _id : string,
    code : string,
    title : string,
    cost : number,
    stock : boolean | number,
    description : string,
    variations : Variation[],
    images : string[],
    category : string,
    sizes : Size[],
}

interface Category {
    _id : string,
    label : string
}

export {
    Size,
    Product
}