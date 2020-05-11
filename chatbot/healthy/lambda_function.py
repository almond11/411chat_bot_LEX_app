from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):

    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
    # Parallel Node Search
    cypher_query1 = "call apoc.search.node({Recipes: ['protein','rating']},'>','4') YIELD node AS n RETURN n.recipeName order by  n.sodium+n.fat+n.calories  LIMIT 10"
    result = session.run(cypher_query1,{})
    session.close()
    ans=""
    for record in result:
        ans+=str(record['n.recipeName'])+" -- "
    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "TOP 10 high-rating healthy recipes are "+ans+"!" }   }    }    
    return response