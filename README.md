traderloo
=========

The name not super catchy
We'll figure that out later
Just name dev stuff traderloo for now

## Descriptive list of planned end points

- GET /users
    - Returns a list of active users 
    - DONE

- GET /account
    - Returns statistics about the trading account
    - Includes a list of unclosed trades
    - DONE

- GET /account/balances
    - Returns an array of all balances
    - DONE   

- GET /stocks
    - Returns a list of stocks to trade
    - DONE, too slow needs work

- GET /stocks/{code}
    - Returns details for the specified stock
    - DONE

- GET /trades
    - Returns a list of all trades
    - DONE

- POST /trades
    - Must be called with symbol and quantity params
    - Opens and performs execution for new trade
    - Returns trade object on success
    - DONE

- PUT /trades
    - Must be called with trade_id as param
    - Use this end point to close the specified trade
    - Returns the trade object on success
    - DONE

- Additional notes
    - Every API call is first validated for a session
    - If user is found to be logged out, returns error