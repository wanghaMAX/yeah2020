#include <httplib.h>
#include <iostream>

void get(httplib::Client cli, char* txt){
    auto res = cli.Get(txt);
    if (res && res->status == 200) {
        std::cout << res->body << std::endl;
    }
}

void post(httplib::Client cli){
    httplib::Params params{
        { "name", "john" },
        { "note", "coder" }
    };
    auto res = cli.Post("/post", params);
    if (res && res->status == 200) {
        std::cout << res->body << std::endl;
    }
}

int main(void){
    // IMPORTANT: 1st parameter must be a hostname or an IP adress string.
    httplib::Client cli("localhost", 2345);

    std::cout << "example get:\n";
    get(cli, "/hi");
    std::cout << "example post:\n";
    post(cli);
}
