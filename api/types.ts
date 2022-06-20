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

export {
    Size,
    Product
}