import express, { application, Express } from "express";
import Mongo, { MongoClient } from "mongodb"

let expressApp : Express
let mongoInterface : MongoClient

interface IDbCredentials {
    port : number,
    host : string
}

const Init = async (port : number, database : IDbCredentials) => {
    expressApp = express()
    expressApp.listen(port, () => {
        console.log(`Server started on ${port} 3000 in ` + (new Date().getTime() - time0) + " ms");
    })

    mongoInterface = new MongoClient(`mongodb://${database.host}:${database.port}`)
}



const time0 = new Date().getTime();


Init(3000, {
    port : 27017,
    host : "localhost"
})