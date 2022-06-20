import Mongo, { MongoClient, ObjectId } from "mongodb"
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

Init(3000, {
    port : 27017,
    host : "localhost"
})