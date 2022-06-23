import Mongo, { MongoClient, ObjectId, WithId } from "mongodb"
import { Init as InitExpress, BaseListener } from './Requests'

import {
    Product
} from './types'

let mongoInterface : MongoClient
let db : Mongo.Db


interface IDbCredentials {
    port : number,
    host : string
}


const Init = async (port : number, database : IDbCredentials) => {
    InitExpress(port)
    let time = new Date().getTime();
    mongoInterface = new MongoClient(`mongodb://${database.host}:${database.port}`)
    await mongoInterface.connect()
    console.log(`MongoDB connected in ` + (new Date().getTime() - time) + " ms");
    db = mongoInterface.db("motor")
}

BaseListener("/products/getAll", (req, res) => {
    db.collection("products").find({}).toArray((err, result) => {
        if (err) { res.send(err); return; }
        res.send(result)
    })
})

BaseListener("/products/get", (req,res) => {
    const Data : Product = req.body;
    db.collection("products").findOne({ _id: new ObjectId(Data._id) }, (err, result) => {
        if (err) { res.send(err); return; }
        res.send(result)
    })
})

BaseListener("/products/find", (req,res) => {
    const query = req.body;

    let reg = new RegExp(query.value, "i")

    db.collection("products").find({ [query.field] : { $regex: reg  } }).toArray((err, result) => {
        if (err) { res.send(err); return; }
        res.send(result)
    })
})

BaseListener("/products/edit", (req,res) => { 
    console.log(req.body.update)
    db.collection("products").findOneAndUpdate({ "_id" : new ObjectId(req.body._id) }, {
        $set: req.body.update
    })

    res.sendStatus(200);
});

BaseListener("/products/add", (req, res) => {
    const { body } = req;
    db.collection("products").insertOne(body, (err, result) => {
        res.send(result)
    })
});

BaseListener("/products/clear", (req,res) => {
    db.collection("products").deleteMany({}, (err, result) => {});
    res.sendStatus(200);
})

BaseListener("/products/delete", (req,res) => {
    const { _id } = req.body;

    db.collection("products").deleteOne({ _id: new ObjectId(_id) }, (err, result) => { if (err) return res.sendCode(500); res.send(result); });
});

BaseListener("/categories/add", (req,res) => {
    const { body } = req;

    db.collection("categories").insertOne(body, (err, result) => {
        if (err) { res.sendCode(500); return; }
        res.send(result);
    });
})

BaseListener("/categories/del", (req,res) => {
    const { _id } = req.body;
    db.collection("categories").deleteOne({ _id: new ObjectId(_id) }, (err, result) => { if (err) return res.sendCode(500); res.send(result); });
})

BaseListener("/categories/getAll", (req,res) => {
    
    db.collection("categories").find({}).toArray((err, result) => {
        res.send(result);
    })
    
})

BaseListener("/categories/list", (req,res) => {
    db.collection("categories").find({}).toArray((_, result) => {
        db.collection("products").find({}).toArray((_, result2) => {
            res.send(result.map((cat) => {
                console.log("[...] Mapping category " + cat.label)
                let myProducts = result2.filter((product) => { 
                    return new ObjectId(product.category).equals(cat._id) 
                });

                return { ...cat, products: myProducts ? myProducts : [] }
            }));
        })
    })
})

BaseListener("/categories/edit", (req,res) => {
    db.collection("categories").findOneAndUpdate({ "_id" : new ObjectId(req.body._id) }, {
        $set: req.body.update
    });

    res.sendStatus(200);
})

Init(3000, {
    port : 27017,
    host : "localhost"
})