import express, { application, Express } from "express";


let expressApp : Express = express()
expressApp.use(express.json())

const Init = (port : number) => {
    const time0 = new Date().getTime();
    expressApp.listen(port, () => {
        console.log(`Server started on ${port} in ` + (new Date().getTime() - time0) + " ms");
    })
}

export { Init }

const AuthKey = "yDDxw9mTdYM!cEWDK2@yuXdSJH3-Xt2?";


function tryAndParse(body : any) {
    for(let [index,value] of Object.entries(body)) {
        if (!Number.isNaN(Number(value))) {
            body[index] = Number(value)
            continue;
        }
        
        try {
            body[index] = JSON.parse(value as string)
        } catch(e) { }
    }

    console.log(body)

    return body;
}

const BaseListener = (url : string, cb : (req, res) => any) => {
    expressApp.post(url, (req, res) => {
        if (req.headers["auth-key"] !== AuthKey) {
            res.sendStatus(403)
            return;
        }
        req.body = tryAndParse(req.body)
        cb(req, res)
    })
}

export {
    BaseListener
}

