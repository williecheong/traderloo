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

- GET /stocks
    - Returns a list of stocks to trade

- GET /stocks/{code}
    - Returns details for the specified stock

- GET /trades
    - Returns a list of all trades

- POST /trades
    - Must be called with trade params
    - Opens and performs execution for new trade
    - Returns trade id on success

- PUT /trades/{id}
    - Must be called with trade params
    - Use this end point to close the specified trade
    - Returns the trade id on success

- Additional notes
    - Every API call is first validated for a session
    - If user is found to be logged out, returns error