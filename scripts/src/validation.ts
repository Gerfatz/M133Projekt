class Validator{
    static ErrorModels: Array<ErrorModel>
    static Create(models: Array<ErrorModel>){
        this.ErrorModels = models;
    }
}

class ErrorModel{
    name: string;
    message: string;
    value: any;
}