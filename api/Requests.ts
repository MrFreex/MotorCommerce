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

const BaseListener = (url : string, cb : (req, res) => any) => {
    expressApp.post(url, (req, res) => {
        if (req.headers["auth-key"] !== AuthKey) {
            res.sendStatus(403)
            return;
        }
        cb(req, res)
    })
}

export {
    BaseListener
}

