import express, { application, Express } from "express";
import Mongo, { MongoClient } from "mongodb"

let expressApp : Express = express()
expressApp.use(express.json())
let mongoInterface : MongoClient
let db : Mongo.Db



interface IDbCredentials {
    port : number,
    host : string
}

const time0 = new Date().getTime();
const Init = async (port : number, database : IDbCredentials) => {
    
    expressApp.listen(port, () => {
        console.log(`Server started on ${port} in ` + (new Date().getTime() - time0) + " ms");
    })

    let time = new Date().getTime();
    mongoInterface = new MongoClient(`mongodb://${database.host}:${database.port}`)
    await mongoInterface.connect()
    console.log(`MongoDB connected in ` + (new Date().getTime() - time) + " ms");
    db = mongoInterface.db("motor")
}

expressApp.post("/products/get", (req, res) => {
    
    db.collection("products").find({}).toArray((err, result) => {
        if (err) { res.send(err); return; }
        res.send(result)
    })

})

Init(3000, {
    port : 27017,
    host : "localhost"
})