from __future__ import print_function
from urllib.request import Request, urlopen
import neo4j
from neo4j.v1 import GraphDatabase, basic_auth
import json

url = "bolt://ec2-54-160-22-105.compute-1.amazonaws.com"
def lambda_handler(event,context):
    results = []
    recipe = event['currentIntent']['slots']['recipe']

    driver = GraphDatabase.driver(url, auth=basic_auth("neo4j", "i-0920a3a98b16e7ac2"), encrypted=False)
    session = driver.session()
    # query and read
    cypher_query1 = 'MATCH (r:Recipes{recipeName:"'+recipe+'"}) RETURN r.calories as calories,r.fat as fat,r.protein as protein,r.sodium as sodium'
    """
  r.calories as calories,r.fat as fat,r.protein as protein,r.sodium as sodium'

    """
    result = session.run(cypher_query1,{})
    session.close()
    for r in result:
        ans= r["calories"]+ "calories--" +r["fat"]+ " fat--"+r["protein"]+" protein--" +r["sodium"]+" sodium" 
    
         
    response =  {"dialogAction":{"fulfillmentState":"Fulfilled","type":"Close","message": {"contentType":"PlainText", "content": "Nutritions info : "+ans+ "!" }   }    }    
    return response